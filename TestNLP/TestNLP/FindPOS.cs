﻿using System;
using System.Collections.Generic;
using System.Configuration;
using System.Linq;
using System.Text;

namespace TestNLP
{
    public class FindPOS
    {
        private OpenNLP.Tools.Tokenize.EnglishMaximumEntropyTokenizer tokenizer;
        private OpenNLP.Tools.PosTagger.EnglishMaximumEntropyPosTagger posTagger;
        private OpenNLP.Tools.SentenceDetect.MaximumEntropySentenceDetector sentenceDetector;

        private string modelPath;

        public FindPOS()
        {
            modelPath = ConfigurationManager.AppSettings["MaximumEntropyModelDirectory"];
        }

        public void GetPOS(string paragraph)
        {
            StringBuilder output = new StringBuilder();

            string[] sentences = this.SplitSentences(paragraph);

            foreach( string sentence in sentences)
            {
                string[] tokens = TokenizeSentence(sentence);
                string[] tags = PosTagTokens(tokens);

                for (int currentTag = 0; currentTag < tags.Length; currentTag++)
                {
                    output.Append(tokens[currentTag]).Append("/").Append(tags[currentTag]).Append(" ");
                }

                output.Append("\r\n\r\n");
            }

            Console.Write(output.ToString());
        }

        /// <summary>
        /// Brake out each sentence from the paragraph
        /// </summary>
        /// <param name="paragraph"></param>
        /// <returns></returns>
        private string[] SplitSentences(string paragraph)
        {
            if (sentenceDetector == null)
            {
                sentenceDetector = new OpenNLP.Tools.SentenceDetect.EnglishMaximumEntropySentenceDetector(modelPath + "EnglishSD.nbin");
            }

            return sentenceDetector.SentenceDetect(paragraph);
        }

        /// <summary>
        /// Turn the sentence into individual words
        /// </summary>
        /// <param name="sentence"></param>
        /// <returns></returns>
        private string[] TokenizeSentence(string sentence)
        {
            if (tokenizer == null)
            {
                tokenizer = new OpenNLP.Tools.Tokenize.EnglishMaximumEntropyTokenizer(modelPath + "EnglishTok.nbin");
            }

            return tokenizer.Tokenize(sentence);
        }

        /// <summary>
        /// Tag each word with a part of speech
        /// </summary>
        /// <param name="tokens"></param>
        /// <returns></returns>
        private string[] PosTagTokens(string[] tokens)
        {
            if (posTagger == null)
            {
                posTagger = new OpenNLP.Tools.PosTagger.EnglishMaximumEntropyPosTagger(modelPath + "EnglishPOS.nbin", modelPath + @"\Parser\tagdict");
            }

            return posTagger.Tag(tokens);
        }
    }
}
